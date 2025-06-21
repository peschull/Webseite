import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import './style.css';
import './editor.css';
import Edit from './save';

registerBlockType('verein/dokumentensammlung', {
    title: __('Dokumentensammlung', 'verein'),
    icon: 'media-document',
    category: 'widgets',
    edit: Edit,
    save: () => null,
});