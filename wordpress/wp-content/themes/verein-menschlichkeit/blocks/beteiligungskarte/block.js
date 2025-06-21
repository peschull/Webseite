import { registerBlockType } from '@wordpress/blocks';
import './style.css';
import './editor.css';

registerBlockType('verein/beteiligungskarte', {
  title: 'Beteiligungskarte',
  icon: 'location-alt',
  category: 'widgets',
  edit: () => <div className="beteiligungskarte-block">Beteiligungskarte (Editor)</div>,
  save: () => <div className="beteiligungskarte-block">Beteiligungskarte (Frontend)</div>,
});
