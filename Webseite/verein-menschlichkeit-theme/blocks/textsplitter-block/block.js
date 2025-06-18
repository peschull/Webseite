import { registerBlockType } from '@wordpress/blocks';
import './style.css';
import './editor.css';
import Edit from './save';

registerBlockType('verein/textsplitter-block', {
	title: 'Textsplitter Block',
	icon: 'editor-table',
	category: 'widgets',
	edit: Edit,
	save: () => null,
});
