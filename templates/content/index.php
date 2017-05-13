<div id="noteEditorMenu">
	<ul class="clearfix">
		<li><span>File</span>
			<ul class="noteEditorSubMenu">
				<li id="createNewNoteButton">New note</li>
				<li id="renameFolderButton">Move to</li>
			</ul>
		</li>
		<li><span>Text</span>
			<ul class="noteEditorSubMenu">
				<li><span id="editorBoldButton">Bold</span></li>
				<li><span id="editorItalicButton">Italic</span></li>
				<li><span id="editorStrikeButton">Strike</span></li>
				<li><span id="editorUnderlineButton">Underline</span></li>
			</ul>
		</li>
		<li><span>Paragraph</span>
			<ul class="noteEditorSubMenu">
				<li><span id="editorLeftButton">Align Left</span></li>
				<li><span id="editorRightButton">Align Right</span></li>
				<li><span id="editorCenterButton">Center</span></li>
				<li><span id="editorJustifyButton">Justify</span></li>
			</ul>
		</li>
	</ul>
	<!-- <span class="icon-triangle-e ncIcons"></span>
	<div class="noteEditorMenuWidget">
		<div class="noteEditorMenuDropDownWidget">
			<span>Files</span>
			<span class="icon-triangle-s ncIcons"></span>
		</div>
	</div>
	<div class="noteEditorMenuWidget">
		<div class="noteEditorMenuWidgetHighlight">
			<button id="bold">B</button>
		</div>
	</div>
	<div class="noteEditorMenuWidget">
		<div class="noteEditorMenuWidgetHighlight">
			<button>I</button>
		</div>
	</div>
	<div class="noteEditorMenuWidget">
		<div class="noteEditorMenuWidgetHighlight">
			<button>U</button>
		</div>
	</div>
	<div class="noteEditorMenuWidget">
		<div class="noteEditorMenuWidgetHighlight">
			<button>L</button>
		</div>
	</div>
	<div class="noteEditorMenuWidget">
		<div class="noteEditorMenuWidgetHighlight">
			<button>C</button>
		</div>
	</div>
	<div class="noteEditorMenuWidget">
		<div class="noteEditorMenuWidgetHighlight">
			<button>R</button>
		</div>
	</div>
	<div class="noteEditorMenuWidget">
		<div class="noteEditorMenuWidgetHighlight">
			<button>J</button>
		</div>
	</div>
	<div class="noteEditorMenuWidget">
		<div class="noteEditorMenuWidgetHighlight">
			<button>A</button>
		</div>
	</div>
	<div class="noteEditorMenuWidget">
		<div class="noteEditorMenuWidgetHighlight">
			<button>L</button>
		</div>
	</div> -->
</div>

<div id="noteContent">
	<div>
		<input id="noteNameEditor">
	</div>

	<iframe id="noteEditor"></iframe>
</div>

<div id="modalContainer"></div>
<!-- <div class="modal closed" id="modal">
	<div class="modalContent">
		<span>Folder Name:</span>
		<input id="folderNameEditor">
	</div>
	<div class="modalButtons">
		<button class="modalCancelButton">Cancel</button>
		<button class="modalDoneButton">Done</button>
	</div>
</div> -->
<div class="modal-overlay closed" id="modal-overlay"></div>

<script id="modalTemplate" type="text/x-handlebars-template">
	<div class="modal closed" id="modal">
		<div class="modalContent">
			<span>{{modalText}}</span>
			<input id="{{modalInputId}}">
		</div>
		<div class="modalButtons">
			<button id="{{modalCancelId}}">Cancel</button>
			<button id="{{modalDoneId}}">Done</button>
		</div>
	</div>
</script>
