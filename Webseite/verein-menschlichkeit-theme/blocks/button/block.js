import { registerBlockType } from '@wordpress/blocks';
import './style.css';
import './editor.css';

registerBlockType('verein/button', {
  title: 'Button',
  icon: 'button',
  category: 'widgets',
  edit: () => <button className="button-block">Button (Editor)</button>,
  save: () => <button className="button-block">Button (Frontend)</button>,
});
