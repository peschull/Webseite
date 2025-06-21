import { registerBlockType } from '@wordpress/blocks';
import './style.css';
import './editor.css';

registerBlockType('verein-menschlichkeit/auszeichnungen', {
  title: 'Auszeichnungen als Medaillenreihe',
  icon: 'awards',
  category: 'widgets',
  edit: () => <div className="auszeichnungen-block">Auszeichnungen (Editor)</div>,
  save: () => <div className="auszeichnungen-block">Auszeichnungen (Frontend)</div>,
});
