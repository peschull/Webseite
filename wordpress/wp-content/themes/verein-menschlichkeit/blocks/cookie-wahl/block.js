import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import './style.css';
import './editor.css';
import Edit from './save';

registerBlockType('verein/cookie-wahl', {
    title: __('Cookie Wahl', 'verein'),
    icon: 'shield',
    category: 'widgets',
    edit: Edit,
    save: () => null,
});