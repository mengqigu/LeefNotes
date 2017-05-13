<!-- <div>
<span id="createNewNote">Create a new Note</span>
</div> -->

<ul id="notesList" class="with-icon">
</ul>

<!-- Need to add/remove class open to toggle collapse -->
<!-- <ul class="with-icon">
    <li class="collapsible open">
        <button class="collapse"></button>
        <a href="#" class="icon-folder svg">Folder name</a>
        <ul>
            <li class='noteNameNaviLi'>
                <span class='noteNameNavi' id='noteId1'>1213</span>
            </li
        </ul>
    </li>
</ul> -->

<!-- The generated html is added to the html of #notesList -->
<script id="noteNameNaviTemplate" type="text/x-handlebars-template">
    {{#each noteNavis}}
    <li class='noteNameNaviLi'>
        <span class='noteNameNavi' id='{{noteNaviId}}'>{{noteTitle}}</span>
        <button class='deleteNote icon-delete svg' id='{{noteNaviDelteId}}' title='delete'></button>
    </li>
    {{/each}}
</script>

<!-- TODO:  Extra new line due to handlebarjs
    https://github.com/wycats/handlebars.js/pull/336
-->
<script id="noteNameNaviTemplateFolder" type="text/x-handlebars-template">
    {{#each folders}}
        {{#if folderName}}​
    <li class="collapsible">
        <button class="collapse"></button>
        <a href="#" class="icon-folder svg folderName">{{folderName}}</a>
        <ul>
            {{#each folderNotesList}}
            <li>
                <span class='noteNameNavi' id='{{noteNaviId}}'>{{noteTitle}}</span>
            </li>
            {{/each}}
        </ul>
    </li>
        {{else}}
            {{#each folderNotesList}}
    <li class='noteNameNaviLi'>
        <span class='noteNameNavi' id='{{noteNaviId}}'>{{noteTitle}}</span>
    </li>
            {{/each}}
	   {{/if}}
    {{/each}}
</script>
