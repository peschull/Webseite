import { registerBlockType } from '@wordpress/blocks';
import './style.css';
import './editor.css';

registerBlockType('verein/button-row', {
  title: 'Button Row',
  icon: 'editor-table',
  category: 'widgets',
  edit: () => (
    <div className="button-row-block">
      <button>Button 1</button>
      <button>Button 2</button>
    </div>
  ),
  save: () => (
    <div className="button-row-block">
      <button>Button 1</button>
      <button>Button 2</button>
    </div>
  ),
});
