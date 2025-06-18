import { registerBlockType } from '@wordpress/blocks';
import './style.css';
import './editor.css';

registerBlockType('verein/aktionsblock-rueckmeldeformular', {
  title: 'Aktionsblock Rückmeldeformular',
  icon: 'feedback',
  category: 'widgets',
  edit: () => <div className="aktionsblock-rueckmeldeformular-block">Rückmeldeformular (Editor)</div>,
  save: () => <div className="aktionsblock-rueckmeldeformular-block">Rückmeldeformular (Frontend)</div>,
});
