import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import './style.css';
import './editor.css';
import Edit from './save';

registerBlockType('verein/ehrenamtliche-uebersicht', {
    title: __('Ehrenamtliche Übersicht', 'verein'),
    icon: 'groups',
    category: 'widgets',
    edit: Edit,
    save: () => null,
});