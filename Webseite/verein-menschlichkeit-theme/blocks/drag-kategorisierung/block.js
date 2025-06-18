import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import './style.css';
import './editor.css';
import Edit from './save';

registerBlockType('verein/drag-kategorisierung', {
    title: __('Drag Kategorisierung', 'verein'),
    icon: 'category',
    category: 'widgets',
    edit: Edit,
    save: () => null,
});