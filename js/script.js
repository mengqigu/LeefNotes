/**
 * Nextcloud - mgleefnotes
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Mengqi Gu <mengqigu@gmail.com>
 * @copyright Mengqi Gu 2017
 */

(function ($, OC) {
	$(document).ready(function () {
		//***************************MAIN***************************************

		// Setting the height of the editor
		// TODO: figure out how to set this in html
		var appWrapperHeight = $('#app-content-wrapper').height();
		$("#noteContent").height(appWrapperHeight-70);
		$("#noteEditor").height(appWrapperHeight-120);

		var baseUrl = OC.generateUrl('/apps/mgleefnotes');

		var source   = $("#noteNameNaviTemplate").html();
		var generateNoteNaviHTML = Handlebars.compile(source);
		var generateFolderHTML = Handlebars.compile(
			$("#noteNameNaviTemplateFolder").html());
		var generateModalHTML = Handlebars.compile(
			$("#modalTemplate").html());

		// Id field stored in database, this is modifyed by various callbacks
		var currentNoteId;

		// Modify #notesList by adding notes names to the list
		loadNoteNavi();

		// Turn on design mode
		getIFrameDocument("noteEditor").designMode = "On";

		// Register the rte editor funcionalities
		renderRTEButtonsFunctions();

		// Register the callbacks of various modals
		renderModalInteractionHandling();

		// Register user interaction handling for note and note name editors
		renderEditorInteractionHandling();

		// Register user interaction hanling for note navigation
		noteNavigationInteractionHandling();

		// ******************FUNCTION DEFINITIONS*******************************
		/*
		Loades the note navi menu and sets the default note
		*/
		function loadNoteNavi(){
			$.ajax({
				url: baseUrl + '/notes',
				type: 'GET'
			}).done(function (response) {
				var noteNaviList = [];
				var folderList = [];
				var folderNameToListNotebookObj = {};

				if (response.length === 0) {
					// TODO
				} else {
					$("#notesList").empty();

					// Generate note navigation html using handlabrs template
					for (var i = 0; i < response.length; i ++) {
						var currNoteNaviId = "noteId" + response[i]["id"];
						var currNoteDelteId = "noteDelete" + response[i]["id"];

						var currFolderName = response[i]["folder"];
						var currNoteTitle = response[i]["title"];
						var currNoteNameList = [];

						if (currFolderName in folderNameToListNotebookObj) {
							currNoteNameList =
							folderNameToListNotebookObj[currFolderName];
						}

						var currNaviContext = {
							noteTitle: response[i]["title"],
							noteNaviId: currNoteNaviId,
							noteNaviDelteId: currNoteDelteId
						};
						currNoteNameList.push(currNaviContext);
						folderNameToListNotebookObj[currFolderName] =
						currNoteNameList;

						var currFolderContext = {
							folderName: response[i]["folder"]
						};

						folderList.push(currFolderContext);
						noteNaviList.push(currNaviContext);
					}
					console.log(folderNameToListNotebookObj);

					// var templateContext = {
					// 	noteNavis: noteNaviList
					// };
					// var noteNaviHTML = generateNoteNaviHTML(templateContext);
					// $('#notesList').html(noteNaviHTML);

					// Generate context for rendering template
					folderList = [];
					for (fName in folderNameToListNotebookObj) {
						var currFolderContext2 = {
							folderName: fName,
							folderNotesList: folderNameToListNotebookObj[fName]
						};
						folderList.push(currFolderContext2);
					}

					// Context to handlebarjs:
					// {folders}
					// - folders -> [currFolderContext2, ...]
					// - - currFolderContext2: {folderName, folderNotesList}
					// - - - folderName: string representing the name of folder
					// - - - folderNotesList -> [notebooKContext, ...]
					// - - - - notebookContext: {noteTitle, noteNaviId, noteDelId}
					var folderContext = {
						folders: folderList
					};

					var folderNaviHTML = generateFolderHTML(folderContext);
					$('#notesList').html(folderNaviHTML);

					// Display the newest note so that this func could be used in creating new notes
					defaultNoteId = response[response.length-1]["id"];
					setDefaultNote(defaultNoteId);
				}
			}).fail(function (response, code) {
				console.log("Failure! " + code);
			});
		}

		// functions to modify note content
		function changeNoteTitle(newTitle) {
				// $('#noteName').text(newTitle);
				$('#noteNameEditor').val(newTitle);
		}

		function changeNoteEditorContent(newContentHtml) {
				$("#noteEditor").contents().find("body").html(newContentHtml);
				// $("#noteEditor").val(newContentHtml);
		}

		function getNoteEditorContent() {
			return $('#noteEditor').contents().find('html').html();
		}

		// Updates the note in the back end and the note navigation
		// The note editor is responsibe for updating its own content
		// TODO: update call save note folder name
		function updateNote(newTitle, newContent, noteId, folderName) {
			var fName = folderName;
			if (fName == "") {
				// GET the folder name of note noteId
				$.ajax({
					url: baseUrl + '/notes/' + noteId,
					type: 'GET'
				}).done(function(response){
					fName = response["folder"];
					var note = {
						title: newTitle,
						content: newContent,
						folder: fName
					};

					$.ajax({
						url: baseUrl + '/notes/' + noteId,
						type: 'PUT',
						contentType: 'application/json',
						data: JSON.stringify(note)
					}).done(function (response) {
						// TODO
						var noteNameNaviId = '#noteId' + noteId;
						$(noteNameNaviId).text(newTitle);
					}).fail(function (response, code) {
						console.log("Failure! " + code);
					});
				}).fail(function(response,code){
					console.log("Failure! " + code);
				});
			} else {
				// Updated new folder name, need to reload note navi
				var note = {
					title: newTitle,
					content: newContent,
					folder: fName
				};

				$.ajax({
					url: baseUrl + '/notes/' + noteId,
					type: 'PUT',
					contentType: 'application/json',
					data: JSON.stringify(note)
				}).done(function (response) {
					// TODO
					var noteNameNaviId = '#noteId' + noteId;
					$(noteNameNaviId).text(newTitle);
					loadNoteNavi();
				}).fail(function (response, code) {
					console.log("Failure! " + code);
				});
			}
		}

		// Set and display default note, 0 for no notes
		function setDefaultNote(noteId){
			if (noteId <= 0) {
				// TODO: current noteId undefined here. Need to think through
				changeNoteTitle("Creat a new note!");
			} else {
				$.ajax({
					url: baseUrl + '/notes/' + noteId,
					type: 'GET'
				}).done(function (response) {
					currentNoteId = noteId;
					changeNoteTitle(response["title"]);
					changeNoteEditorContent(response["content"]);
				}).fail(function (response, code) {
					console.log("Failure! " + code);
				});
			}
		}

		/*
		Register callbacks for rte editor menu buttons
		*/
		function renderRTEButtonsFunctions() {
			$('#editorBoldButton').on('click', function(){
				execCommandBold('noteEditor');
			});

			$('#editorItalicButton').on('click', function(){
				execCommandItalic('noteEditor');
			});

			$('#editorStrikeButton').on('click', function(){
				execCommandStrikeThrough('noteEditor');
			});

			$('#editorUnderlineButton').on('click', function(){
				execCommandUnderline('noteEditor');
			});

			$('#editorLeftButton').on('click', function(){
				execCommandJustifyLeft('noteEditor');
			});

			$('#editorRightButton').on('click', function(){
				execCommandJustifyRight('noteEditor');
			});

			$('#editorCenterButton').on('click', function(){
				execCommandJustifyCenter('noteEditor');
			});

			$('#editorJustifyButton').on('click', function(){
				execCommandJustify('noteEditor');
			});

			$('#renameFolderButton').on('click',function(){
				// This can be clicked only when class closed is on
				generateRenameFolderModalSource();
				toggleModalVisibility();
			});

			$('#createNewNoteButton').on('click',function(){
				// This can be clicked only when class closed is on
				generateNewNoteModalSource();
			    toggleModalVisibility();
			});
		}

		function renderModalInteractionHandling() {
			// Callbacks for the modal to rename folders
			$('body').on('click', 'button#modalDoneButton', function() {
				var newFolderName = $('#folderNameEditor').val();
				var noteContent = getNoteEditorContent();
				var noteName = $('#noteNameEditor').val();
				updateNote(noteName, noteContent, currentNoteId, newFolderName);
				toggleModalVisibility();
			});

			$('body').on('click', 'button#modalCancelButton', function() {
				toggleModalVisibility();
			});

			// Modal handlers for create new note
			$('body').on('click', 'button#modalDoneButtonNewNote', function() {
				var newNoteName = $('#modalNoteNameEditorNewNote').val();
				if (!newNoteName == "") {
					var note = {
						title: newNoteName,
						content: "",
						folder: ""
					};

					$.ajax({
						url: baseUrl + '/notes',
						type: 'POST',
						contentType: 'application/json',
						data: JSON.stringify(note)
					}).done(function (response) {
						loadNoteNavi();
					}).fail(function (response, code) {
						console.log("Failure! " + code);
					});
				}
				toggleModalVisibility();
			});

			$('body').on('click', 'button#modalCancelButtonNewNote', function(){
				toggleModalVisibility();
			});
		}

		// Toggle close/open for the folderNameModal
		function toggleModalVisibility(){
			$('.modal').toggleClass('closed');
			$('.modal-overlay').toggleClass('closed');
		}

		// TODO: have a template for modals,
		// Dynamically generated different types of modals here
		function renderModalSource(context) {
			var modalHTML = generateModalHTML(context);
			$('#modalContainer').html(modalHTML);
		}

	    function generateRenameFolderModalSource() {
			var modalContext = {
				modalText: "Folder Name: ",
				modalInputId: "folderNameEditor",
				modalDoneId: "modalDoneButton",
				modalCancelId: "modalCancelButton"
			};
			renderModalSource(modalContext);
		}

		function generateNewNoteModalSource() {
			var modalContext = {
				modalText: "Note Name: ",
				modalInputId: "modalNoteNameEditorNewNote",
				modalDoneId: "modalDoneButtonNewNote",
				modalCancelId: "modalCancelButtonNewNote"
			};
			renderModalSource(modalContext);
		}

		function generateWelcomeModalSource() {

		}

		/*
		Handles the user interaction in the note content and note name editors
		TODO: this function uses closure variable currentNoteId
		*/
		function renderEditorInteractionHandling() {
			$('#noteNameEditor').on('blur',function(){
				var noteEditorContent = getNoteEditorContent();
				updateNote($('#noteNameEditor').val(),
				noteEditorContent,currentNoteId,"");
			});

			$('#noteNameEditor').keypress(function (e) {
				var key = e.which;
				if(key == 13)  // the enter key code
				{
					$('#noteNameEditor').blur();
					return false;
				}
			});

			$('#noteEditor').on('blur',function(){
				console.log("iframe blurring");
				var noteEditorContent = getNoteEditorContent();
				updateNote($('#noteNameEditor').val(),
				noteEditorContent,currentNoteId,"");
			});

			// Saving the note after clicking outside of the iframe editor
			$("#noteEditor").contents().on('focus', function () {
				// console.log("Ifrmae focus");
			}).on('blur', function () {
				// console.log("iFrame blurring");
				var noteEditorContent = getNoteEditorContent();
				updateNote($('#noteNameEditor').val(),
				noteEditorContent,currentNoteId,"");
			});
		}

		/*
		Handles the user interaction in the note navigation
		TODO: this function uses closure variable currentNoteId
		*/
		function noteNavigationInteractionHandling() {
			$('body').on('mouseenter', 'li.noteNameNaviLi', function() {
				var currNoteId = $(this).children(":first").attr("id").charAt(6);
				var delteNoteId = '#noteDelete' + currNoteId;
				$(delteNoteId).show();
			});

			$('body').on('mouseleave', 'li.noteNameNaviLi', function() {
				var currNoteId = $(this).children(":first").attr("id").charAt(6);
				var delteNoteId = '#noteDelete' + currNoteId;
				$(delteNoteId).hide();
			});

			// Show / hide folder contents in note navigation
			$('body').on('click', 'li.collapsible > .folderName', function(){
				$(this).parent().toggleClass("open");
			});

			$('body').on('click', 'span.noteNameNavi', function() {
				// GET the contents of this notebook, change noteContent on success
				var clickedNoteId = $(this).attr("id");
				$.ajax({
					url: baseUrl + '/notes/' + clickedNoteId.charAt(6),
					type: 'GET'
				}).done(function (response) {
					currentNoteId = clickedNoteId.charAt(6);
					changeNoteTitle(response["title"]);
					changeNoteEditorContent(response["content"]);
				}).fail(function (response, code) {
					console.log("Failure! " + code);
				});
				// console.log("Fhatdfd the wuckdsfds again?");
			});

			$('body').on('click', 'button.deleteNote', function() {
				var clickedNoteId = $(this).attr("id").charAt(10);
				$.ajax({
					url: baseUrl + '/notes/' + clickedNoteId,
					type: 'DELETE'
				}).done(function (response) {
					loadNoteNavi();
				}).fail(function (response, code) {
					console.log("Failure! " + code);
				});
			});

			$("#createNewNote").click(function() {
				var note = {
					title: "",
					content: "",
					folder: ""
				};

				$.ajax({
					url: baseUrl + '/notes',
					type: 'POST',
					contentType: 'application/json',
					data: JSON.stringify(note)
				}).done(function (response) {
					// TODO: return the newly created id in this response
					// console.log("Created " + response);

					// Reload the note navi to update the navi and display the new note
					loadNoteNavi();
				}).fail(function (response, code) {
					console.log("Failure! " + code);
				});
			});
		}
	});
})(jQuery, OC);
