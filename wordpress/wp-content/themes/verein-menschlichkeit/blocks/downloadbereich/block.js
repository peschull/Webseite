import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import './style.css';
import './editor.css';
import Edit from './save';

registerBlockType('verein/downloadbereich', {
    title: __('Downloadbereich', 'verein'),
    icon: 'download',
    category: 'widgets',
    edit: Edit,
    save: () => null,
});