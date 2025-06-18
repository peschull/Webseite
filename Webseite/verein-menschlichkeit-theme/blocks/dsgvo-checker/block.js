import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import './style.css';
import './editor.css';
import Edit from './save';

registerBlockType('verein/dsgvo-checker', {
    title: __('DSGVO Checker', 'verein'),
    icon: 'shield',
    category: 'widgets',
    edit: Edit,
    save: () => null,
});