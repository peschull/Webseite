import { registerBlockType } from '@wordpress/blocks';
import './style.css';
import './editor.css';

registerBlockType('verein/auszeichnungen-medaillenreihe', {
  title: 'Auszeichnungen Medaillenreihe',
  icon: 'awards',
  category: 'widgets',
  edit: () => <div className="auszeichnungen-medaillenreihe-block">Auszeichnungen Medaillenreihe (Editor)</div>,
  save: () => <div className="auszeichnungen-medaillenreihe-block">Auszeichnungen Medaillenreihe (Frontend)</div>,
});
