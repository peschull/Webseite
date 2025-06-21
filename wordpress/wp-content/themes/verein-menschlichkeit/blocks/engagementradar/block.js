import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import './style.css';
import './editor.css';
import Edit from './save';

registerBlockType('verein/engagementradar', {
    title: __('Engagementradar', 'verein'),
    icon: 'visibility',
    category: 'widgets',
    edit: Edit,
    save: () => null,
});