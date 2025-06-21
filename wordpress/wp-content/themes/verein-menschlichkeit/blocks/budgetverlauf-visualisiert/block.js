import { registerBlockType } from '@wordpress/blocks';
import './style.css';
import './editor.css';

registerBlockType('verein/budgetverlauf-visualisiert', {
  title: 'Budgetverlauf Visualisiert',
  icon: 'chart-bar',
  category: 'widgets',
  edit: () => <div className="budgetverlauf-visualisiert-block">Budgetverlauf Visualisiert (Editor)</div>,
  save: () => <div className="budgetverlauf-visualisiert-block">Budgetverlauf Visualisiert (Frontend)</div>,
});
