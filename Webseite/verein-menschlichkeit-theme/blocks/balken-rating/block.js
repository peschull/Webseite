import { registerBlockType } from '@wordpress/blocks';
import './style.css';
import './editor.css';

registerBlockType('verein/balken-rating', {
  title: 'Balken-Rating',
  icon: 'star-half',
  category: 'widgets',
  edit: () => <div className="balken-rating-block">Balken-Rating (Editor)</div>,
  save: () => <div className="balken-rating-block">Balken-Rating (Frontend)</div>,
});
