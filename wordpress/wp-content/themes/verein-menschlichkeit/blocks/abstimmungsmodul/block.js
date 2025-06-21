import { registerBlockType } from '@wordpress/blocks';
import './style.css';
import './editor.css';

registerBlockType('verein/abstimmungsmodul', {
  title: 'Abstimmungsmodul',
  icon: 'yes',
  category: 'widgets',
  edit: () => <div className="abstimmungsmodul-block">Abstimmungsmodul (Editor)</div>,
  save: () => <div className="abstimmungsmodul-block">Abstimmungsmodul (Frontend)</div>,
});
