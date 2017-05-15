/**
 *
 * @copyright Copyright (c) 2017, Mengqi Gu (mengqigu@gmail.com)
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

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
