import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import './style.css';
import './editor.css';
import Edit from './save';

registerBlockType('verein/downloadbereich-vorschau-filter', {
    title: __('Downloadbereich Vorschau Filter', 'verein'),
    icon: 'filter',
    category: 'widgets',
    edit: Edit,
    save: () => null,
});