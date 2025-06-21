import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import './style.css';
import './editor.css';
import Edit from './save';

registerBlockType('verein/chat-rueckmeldeblock', {
    title: __('Chat Rückmeldeblock', 'verein'),
    icon: 'format-chat',
    category: 'widgets',
    edit: Edit,
    save: () => null,
});