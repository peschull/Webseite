import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import './style.css';
import './editor.css';
import Edit from './save';

registerBlockType('verein/drag-and-drop-umfrage', {
    title: __('Drag & Drop Umfrage', 'verein'),
    icon: 'feedback',
    category: 'widgets',
    edit: Edit,
    save: () => null,
});