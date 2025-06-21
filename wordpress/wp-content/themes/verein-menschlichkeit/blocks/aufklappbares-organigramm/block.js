import { registerBlockType } from '@wordpress/blocks';
import './style.css';
import './editor.css';

registerBlockType('verein/aufklappbares-organigramm', {
  title: 'Aufklappbares Organigramm',
  icon: 'networking',
  category: 'widgets',
  edit: () => <div className="aufklappbares-organigramm-block">Aufklappbares Organigramm (Editor)</div>,
  save: () => <div className="aufklappbares-organigramm-block">Aufklappbares Organigramm (Frontend)</div>,
});
