import { registerBlockType } from '@wordpress/blocks';
import './style.css';
import './editor.css';

registerBlockType('verein/button-3d', {
  title: '3D-Button',
  icon: 'button',
  category: 'widgets',
  edit: () => <button className="button-3d-block">3D-Button (Editor)</button>,
  save: () => <button className="button-3d-block">3D-Button (Frontend)</button>,
});
