import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import './style.css';
import './editor.css';
import Edit from './save';

registerBlockType('verein/button-row-farbverlauf', {
    title: __('Button Row Farbverlauf', 'verein'),
    icon: 'button',
    category: 'design',
    edit: Edit,
    save: () => null,
});