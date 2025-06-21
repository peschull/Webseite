import { registerBlockType } from '@wordpress/blocks';
import './style.css';
import './editor.css';

registerBlockType('verein/block-404-humor', {
  title: '404-Humor Block',
  icon: 'smiley',
  category: 'widgets',
  edit: () => <div className="block-404-humor-block">404-Humor (Editor)</div>,
  save: () => <div className="block-404-humor-block">404-Humor (Frontend)</div>,
});
