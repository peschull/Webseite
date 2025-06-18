import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import './style.css';
import './editor.css';
import Edit from './save';

registerBlockType('verein/countdown-timer', {
    title: __('Countdown Timer', 'verein'),
    icon: 'clock',
    category: 'widgets',
    edit: Edit,
    save: () => null,
});