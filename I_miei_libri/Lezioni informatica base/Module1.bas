REM  *****  BASIC  *****
Sub ModificaCampoVariabile(nuovoValore as String)
    Dim oDoc As Object
    Dim oTextFieldMasters As Object
    Dim oFieldMaster As Object
    Dim sFieldName As String
    
     oDoc = ThisComponent
    ' Nome del campo utente creato in Inserisci -> Campo -> Altri campi... -> Variabili
    sFieldName = "com.sun.star.text.fieldmaster.User.sp_cognome"
    
    ' Ottiene la collezione dei master dei campi
    oTextFieldMasters = oDoc.getTextFieldMasters()
    
    ' Controlla se il campo esiste
    If oTextFieldMasters.hasByName(sFieldName) Then
        ' Ottiene il master del campo
        oFieldMaster = oTextFieldMasters.getByName(sFieldName)
        
        ' Modifica il valore del campo
        oFieldMaster.Content = nuovoValore
        
        ' IMPORTANTE: Aggiorna i campi nel documento
        oDoc.getTextFields().refresh()
    Else
        MsgBox "Campo '" & sFieldName & "' non trovato."
    End If
End Sub

Sub ValorizzaEtichetta(etichetta as String, testo as String)
    Dim oDoc As Object
    Dim oDrawPage As Object
    Dim oForm As Object
    Dim oTextField As Object
    Dim sText As String

    ' Riferimento al documento corrente
    oDoc = ThisComponent
    
    ' Accede alla drawpage dove sono memorizzati i controlli
    oDrawPage = oDoc.DrawPage
    
    ' Accede al primo formulario (Formulario predefinito)
    oForm = oDrawPage.Forms.getByIndex(0)
    
    ' Ottiene il controllo casella di testo per nome
    oTextField = oForm.getByName(etichetta)
    
    ' Ottiene il testo contenuto
   oTextField.Label=testo
End Sub

Sub AggiornaNominativo(oEvent as Object)
    Dim oTextField As Object
    Dim sText As String

     oTextBox = oEvent.Source
     sText = oTextBox.Text
 
   if (sText<>"") then
      ' Visualizza il testo
      ' MsgBox "Il testo è: " & sText
      ' Split by space
      result = Split(sText, " ")
      'MsgBox "Il testo è: " & sText
      ' call ModificaCampoVariabile(sText)
      call ValorizzaEtichetta("sp_cognome", result(0))
      call ValorizzaEtichetta("sp_nome", result(1))
   else
        ' Visualizza il testo
        MsgBox "Digitare  il cognome (spazio)  il nome" 
    end if
End Sub

Sub AggiornaEtichetta(oEvent as Object)
    Dim oTextField As Object
    Dim sText As String

     oTextBox = oEvent.Source.Model
     sName = oEvent.Source.Model.Name ' casella_nome
     ' MsgBox "nome della casella selezionata " & sName
     sText = oTextBox.Text
 
   if (sText<>"") then
      ' Visualizza il testo
      ' MsgBox "Il testo è: " & sText
      numCaratteri = 8 ' Numero di caratteri da eliminare (es. "casella_")
    
      ' Inizia dalla posizione 9, ovvero elimina i primi 8
      nameModificata = Mid(sName, numCaratteri + 1)
      ' MsgBox "etichetta da modificare  è " & "sp_" & nameModificata
      ' call ModificaCampoVariabile(sText)
      call ValorizzaEtichetta("sp_" & nameModificata, sText)
   else
        ' Visualizza il testo
        MsgBox "Digitare  " & sName 
    end if
End Sub


