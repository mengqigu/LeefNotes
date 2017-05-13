function getIFrameDocument(aID){
    // if contentDocument exists, W3C compliant (Mozilla)
    if (document.getElementById(aID).contentDocument){
        return document.getElementById(aID).contentDocument;
    } else {
        // IE
        return document.frames[aID].document;
    }
}

function execCommandBold(noteEditorId) {
    execRichEditCommand('bold', null, noteEditorId);
}

function execCommandItalic(noteEditorId) {
    execRichEditCommand('italic', null, noteEditorId);
}

function execCommandStrikeThrough(noteEditorId) {
    execRichEditCommand('strikeThrough', null, noteEditorId);
}

function execCommandUnderline(noteEditorId) {
    execRichEditCommand('underline', null, noteEditorId);
}

function execCommandJustifyCenter(noteEditorId) {
    execRichEditCommand('justifyCenter', null, noteEditorId);
}

function execCommandJustify(noteEditorId) {
    execRichEditCommand('justifyFull', null, noteEditorId);
}

function execCommandJustifyLeft(noteEditorId) {
    execRichEditCommand('justifyLeft', null, noteEditorId);
}

function execCommandJustifyRight(noteEditorId) {
    execRichEditCommand('justifyRight', null, noteEditorId);
}

function execRichEditCommand(cmd, arg, noteEditorId){
    document.getElementById(noteEditorId).focus();
    getIFrameDocument(noteEditorId).execCommand(cmd, false, arg);
    // document.execCommand(cmd, false, arg);
    document.getElementById(noteEditorId).contentWindow.focus();
    console.log(getIFrameDocument(noteEditorId).body.innerHTML);
}
