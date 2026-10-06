let globalHeaders = [];
let globalRows = [];

showError(null);

document.getElementById('csvFileInput').addEventListener('change', function (e) {
    // MODIFICA: Prende il primo file dell'array FileList
    const file = e.target.files[0];
    if (!file) return;

    // Ora 'file' ha le proprietà .name e .size corrette
    document.getElementById('fileInfo').textContent = `File selezionato: ${file.name} (${(file.size / 1024).toFixed(1)} KB)`;
    showError(null);

    const reader = new FileReader();
    reader.onload = function (e) {
        try {
            const arrayBuffer = e.target.result;
            const uint8Array = new Uint8Array(arrayBuffer);
            let text = new TextDecoder('utf-8').decode(uint8Array);

            if (text.codePointAt(0) === 0xFFFD || text.includes('\uFFFD')) {
                text = new TextDecoder('windows-1252').decode(uint8Array);
            }
            parseCSV(text);
        } catch (err) {
            showError("Errore durante la lettura: " + err.message);
        }
    };
    reader.readAsArrayBuffer(file); // Ora funziona correttamente
});

function showError(msg) {
    const errDiv = document.getElementById('errorLog');
    if (msg) {
        errDiv.textContent = msg;
        errDiv.style.display = 'block';
    } else {
        errDiv.style.display = 'none';
    }
}

function detectSeparator(lines) {
    const separators = [';', ',', '\t', '|'];
    let maxCount = -1;
    let bestSeparator = ',';
    separators.forEach(sep => {
        const count = lines[0].split(sep).length;
        if (count > maxCount) {
            maxCount = count;
            bestSeparator = sep;
        }
    });
    return bestSeparator;
}

function parseCSVLine(line, separator) {
    const result = [];
    let current = '';
    let inQuotes = false;
    for (let i = 0; i < line.length; i++) {
        const char = line[i];
        if (char === '"') {
            inQuotes = !inQuotes;
        } else if (char === separator && !inQuotes) {
            result.push(cleanValue(current));
            current = '';
        } else {
            current += char;
        }
    }
    result.push(cleanValue(current));
    return result;
}

function cleanValue(val) {
    return val.trim().replace(/^["']|["']$/g, '').trim();
}

function parseCSV(text) {
    const lines = text.split(/\r\n|\n|\r/).map(line => line.trim()).filter(line => line !== '');
    if (lines.length === 0) {
        showError("Il file CSV è vuoto.");
        return;
    }

    const separator = detectSeparator(lines);
    globalHeaders = parseCSVLine(lines[0], separator);
    globalRows = lines.slice(1).map(
        line => parseCSVLine(line, separator));// Popola le colonne di testo da mostrare
    const checkboxGroup = document.getElementById('checkboxGroup');
    checkboxGroup.innerHTML = '';// Popola anche il menu a tendina per la colonna del valore numerico
    const valueSelect = document.getElementById('valueColumnSelect');
    valueSelect.innerHTML = '';// Aggiungi un'opzione "Nessuna somma" di default
    const defaultOpt = document.createElement('option');
    defaultOpt.value = "-1";
    defaultOpt.textContent = "-- Seleziona Colonna Totale --";
    valueSelect.appendChild(defaultOpt);
    let guessIndex = -1;
    globalHeaders.forEach((header, index) => {
        const cleanHeader = header !== '' ? header : `Colonna ${index + 1}`;// Cerca di indovinare se la colonna si chiama "totale", "prezzo", "importo" o "quantità"
        const lowerHeader = cleanHeader.toLowerCase();
        if (lowerHeader.includes('totale') ||
            lowerHeader.includes('prezzo') ||
            lowerHeader.includes('importo') ||
            lowerHeader.includes('quant') ||
            lowerHeader.includes('valore')) {
            guessIndex = index;
        }// Checkbox visive per il testo
        const label = document.createElement('label');
        label.className = 'checkbox-label';
        if (index === 0)
            label.classList.add('active');
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox'; checkbox.value = index;
        if (index === 0) checkbox.checked = true;
        checkbox.addEventListener('change',
            function () {
                this.checked ? label.classList.add('active') : label.classList.remove('active');
                generateChecklist();
            });
        label.appendChild(checkbox);
        label.appendChild(document.createTextNode(cleanHeader));
        checkboxGroup.appendChild(label);// Opzioni del menu a tendina numerico
        const opt = document.createElement('option');
        opt.value = index; opt.textContent = cleanHeader;
        valueSelect.appendChild(opt);
    });// Se ha indovinato la colonna dei totali, la imposta automaticamente
    if (guessIndex !== -1) {
        valueSelect.value = guessIndex;
    }
    valueSelect.addEventListener('change', generateChecklist);
    document.getElementById('columnSelectSection').style.display = 'block'; generateChecklist();
}

function generateChecklist() {
    const checklistContainer = document.getElementById('checklist');
    const counterSection = document.getElementById('counterSection');
    const oldItems = checklistContainer.querySelectorAll('.checklist-item');
    oldItems.forEach(item => item.remove()
    );
    const checkedBoxes = Array.from(document.querySelectorAll('#checkboxGroup input[type="checkbox"]:checked'));
    const selectedIndexes = checkedBoxes.map(
        box => parseInt(box.value));
    if (selectedIndexes.length === 0) {
        counterSection.style.display = 'none';
        return;
    }
    let renderedCount = 0;
    const valueColumnIdx = parseInt(document.getElementById('valueColumnSelect').value);
    globalRows.forEach((row, rowIndex) => {
        const rowCells = selectedIndexes.map(
            idx => row[idx]).filter(val => val !== undefined && val !== '');
        if (rowCells.length > 0) {
            renderedCount++;
            const itemDiv = document.createElement('div');
            itemDiv.className = 'checklist-item';
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.id = 'chk-' + rowIndex;
            checkbox.className = 'checklist-trigger';
            // Salviamo il valore numerico associato a questa riga dentro l'elemento HTML del checkbox
            let numericValue = 0;
            if (valueColumnIdx !== -1 && row[valueColumnIdx]) {
                // Pulisce la stringa (toglie €, spazi e converte la virgola in punto decimale)
                let cleanNum = row[valueColumnIdx].replace(/[^0-9,.-]/g, '').replace(',', '.');
                numericValue = parseFloat(cleanNum) || 0;
            }
            checkbox.dataset.valore = numericValue;
            checkbox.addEventListener('change', updateTotals);
            const label = document.createElement('label');
            label.htmlFor = 'chk-' + rowIndex; rowCells.forEach(
                cellText => {
                    const span = document.createElement('span');
                    span.className = 'column-tag';
                    span.textContent = cellText;
                    label.appendChild(span);
                });
            itemDiv.appendChild(checkbox);
            itemDiv.appendChild(label);
            //checklistContainer.insertBefore(itemDiv, counterSection);
            // RIGA NUOVA CORRETTA:
            checklistContainer.appendChild(itemDiv);
        }
    });

    if (renderedCount > 0) {
        counterSection.style.display = 'flex'; updateTotals();
    } else {
        counterSection.style.display = 'none';
    }
}

function updateTotals() {
    const allCheckboxes = Array.from(document.querySelectorAll('.checklist-trigger'));
    const totalItems = allCheckboxes.length;
    const checkedItems = document.querySelectorAll('.checklist-trigger:checked').length;
    const percentage = totalItems > 0 ? Math.round((checkedItems / totalItems) * 100) : 0;
    document.getElementById('counterText').textContent = "Spuntati: " + `${checkedItems} su ${totalItems} (${percentage}%)`;
    document.getElementById('progressBar').style.width = percentage + '%';
    // Calcolo della somma numerica dei totali spuntati rispetto al totale complessivo

    let sommaSpuntati = 0;
    let sommaGenerale = 0;
    allCheckboxes.forEach(
        cb => {
            let val = parseFloat(cb.dataset.valore) || 0; sommaGenerale += val;
            if (cb.checked) {
                sommaSpuntati += val;
            }
        });
    const valueColumnIdx = parseInt(document.getElementById('valueColumnSelect').value);
    const valueBox = document.getElementById('valueText');
    if (valueColumnIdx !== -1) {
        valueBox.style.display = 'inline-block';// Formatta il numero con massimo 2 cifre decimali
        valueBox.textContent = "Somma Spuntati: " + `${sommaSpuntati.toFixed(2)} / ${sommaGenerale.toFixed(2)}`;
    }
    else {
        valueBox.style.display = 'none';
    }
}
    

