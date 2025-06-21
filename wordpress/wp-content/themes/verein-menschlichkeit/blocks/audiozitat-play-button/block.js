import { registerBlockType } from '@wordpress/blocks';
import './style.css';
import './editor.css';

registerBlockType('verein/audiozitat-play-button', {
  title: 'Audiozitat Play-Button',
  icon: 'controls-play',
  category: 'widgets',
  edit: () => <div className="audiozitat-play-button-block">Audiozitat Play-Button (Editor)</div>,
  save: () => <div className="audiozitat-play-button-block">Audiozitat Play-Button (Frontend)</div>,
});
