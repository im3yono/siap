import {
	ClassicEditor,
	Alignment,
	Autoformat,
	AutoImage,
	AutoLink,
	Autosave,
	BalloonToolbar,
	Base64UploadAdapter,
	BlockQuote,
	BlockToolbar,
	Bold,
	Code,
	CodeBlock,
	Essentials,
	FindAndReplace,
	FontBackgroundColor,
	FontColor,
	FontFamily,
	FontSize,
	FullPage,
	GeneralHtmlSupport,
	Heading,
	Highlight,
	HtmlComment,
	HtmlEmbed,
	ImageBlock,
	ImageCaption,
	ImageInline,
	ImageInsert,
	ImageInsertViaUrl,
	ImageResize,
	ImageStyle,
	ImageTextAlternative,
	ImageToolbar,
	ImageUpload,
	Indent,
	IndentBlock,
	Italic,
	Link,
	LinkImage,
	List,
	ListProperties,
	Markdown,
	MediaEmbed,
	Mention,
	Paragraph,
	PasteFromMarkdownExperimental,
	PasteFromOffice,
	RemoveFormat,
	ShowBlocks,
	SourceEditing,
	SpecialCharacters,
	SpecialCharactersArrows,
	SpecialCharactersCurrency,
	SpecialCharactersEssentials,
	SpecialCharactersLatin,
	SpecialCharactersMathematical,
	SpecialCharactersText,
	Strikethrough,
	Subscript,
	Superscript,
	Table,
	TableCaption,
	TableCellProperties,
	TableColumnResize,
	TableProperties,
	TableToolbar,
	TextTransformation,
	TodoList,
	Underline,
	Undo,
	WordCount
} from 'ckeditor5';

import translations from './ckeditor5/translations/id.js';

const LICENSE_KEY = 'GPL'; // or <YOUR_LICENSE_KEY>.

// Editor configuration
const editorConfig = {
	toolbar: {
		items: [
			'undo',
			'redo',
			'|',
			'heading',
			'|',
			'fontFamily',
			'fontSize',
			'fontColor',
			'fontBackgroundColor',
			'|',
			'bold',
			'italic',
			'underline',
			'strikethrough',
			'subscript',
			'superscript',
			'code',
			'removeFormat',
			'|',
			'alignment',
			'bulletedList',
			'numberedList',
			'todoList',
			'outdent',
			'indent',
			'|',
			'insertTable',
			'insertImage',
			// 'insertImageViaUrl',
			'mediaEmbed',
			'specialCharacters',
			'highlight',
			'link',
			'blockQuote',
			'codeBlock',
			'htmlEmbed',
			'|',
			'findAndReplace',
			'sourceEditing',
			'showBlocks',
		],
		shouldNotGroupWhenFull: false
	},
	plugins: [
		Alignment,
		Autoformat,
		AutoImage,
		AutoLink,
		Autosave,
		BalloonToolbar,
		Base64UploadAdapter,
		BlockQuote,
		BlockToolbar,
		Bold,
		Code,
		CodeBlock,
		Essentials,
		FindAndReplace,
		FontBackgroundColor,
		FontColor,
		FontFamily,
		FontSize,
		FullPage,
		GeneralHtmlSupport,
		Heading,
		Highlight,
		HtmlComment,
		HtmlEmbed,
		ImageBlock,
		ImageCaption,
		ImageInline,
		ImageInsert,
		ImageInsertViaUrl,
		ImageResize,
		ImageStyle,
		ImageTextAlternative,
		ImageToolbar,
		ImageUpload,
		Indent,
		IndentBlock,
		Italic,
		Link,
		LinkImage,
		List,
		ListProperties,
		Markdown,
		MediaEmbed,
		Mention,
		Paragraph,
		PasteFromMarkdownExperimental,
		PasteFromOffice,
		RemoveFormat,
		ShowBlocks,
		SourceEditing,
		SpecialCharacters,
		SpecialCharactersArrows,
		SpecialCharactersCurrency,
		SpecialCharactersEssentials,
		SpecialCharactersLatin,
		SpecialCharactersMathematical,
		SpecialCharactersText,
		Strikethrough,
		Subscript,
		Superscript,
		Table,
		TableCaption,
		TableCellProperties,
		TableColumnResize,
		TableProperties,
		TableToolbar,
		TextTransformation,
		TodoList,
		Underline,
		Undo,
		WordCount
	],
	balloonToolbar: ['bold', 'italic', '|', 'link', 'insertImage', '|', 'bulletedList', 'numberedList'],
	blockToolbar: [
		'fontSize',
		'fontColor',
		'fontBackgroundColor',
		'|',
		'bold',
		'italic',
		'|',
		'link',
		'insertImage',
		'insertTable',
		'|',
		'bulletedList',
		'numberedList',
		'outdent',
		'indent'
	],
	image: {
		toolbar: [
			'toggleImageCaption',
			'imageTextAlternative',
			'|',
			'imageStyle:inline',
			'imageStyle:wrapText',
			'imageStyle:breakText',
			'|',
			'resizeImage'
		],
		// resizeUnit: 'px',
		// 		resizeOptions: [
		// 				{
		// 						name: 'resizeKeepAspect',
		// 						value: null,
		// 						label: 'Square',
		// 						isDefault: true
		// 				}
		// 		]
	},
	
	fontSize: {
		options: [
				9,
				11,
				12,
				13,
				'default',
				17,
				19,
				21
		]
	},
	menuBar: {
		isVisible: true
	},
	table: {
		contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
	},
	// initialData: undefined,
	placeholder: 'Ketik atau tempelkan konten anda di sini!',
	// language: {ui:'id',content:'id'},
	language: {
		// The UI will be English.
		ui: 'id',

		// But the content will be edited in Arabic.
		content: 'id'
	},
	licenseKey: LICENSE_KEY
};

// Initialize editor function
const initializeEditor = (editorId, wordCountId, menuBarId) => {
	return ClassicEditor.create(document.querySelector(`#${editorId}`), editorConfig)
		.then(editor => {
			if (wordCountId) {
				const wordCount = editor.plugins.get('WordCount');
				document.querySelector(`#${wordCountId}`).appendChild(wordCount.wordCountContainer);
			}

			// if (menuBarId) {
			// 	document.querySelector(`#${menuBarId}`).appendChild(editor.ui.view.menuBarView.element);
			// }

			return editor;
		})
		// .catch(error => console.error('Error initializing editor:', error));
};

// Usage Target
initializeEditor('crt', 'cr_crt');
initializeEditor('tny', 'cr_tny');
for (let i = 1; i <= 5; i++) {
	initializeEditor(`opsi${i}`, `cr_opsi${i}`);
	initializeEditor(`jdh${i}`, `cr_jdh${i}`);
}

