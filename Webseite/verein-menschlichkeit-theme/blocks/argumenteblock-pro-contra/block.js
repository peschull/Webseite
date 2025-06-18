import { registerBlockType } from '@wordpress/blocks';
import './style.css';
import './editor.css';

registerBlockType('verein/argumenteblock-pro-contra', {
  title: 'Argumenteblock Pro/Contra',
  icon: 'list-view',
  category: 'widgets',
  edit: () => <div className="argumenteblock-pro-contra-block">Argumenteblock Pro/Contra (Editor)</div>,
  save: () => <div className="argumenteblock-pro-contra-block">Argumenteblock Pro/Contra (Frontend)</div>,
});
