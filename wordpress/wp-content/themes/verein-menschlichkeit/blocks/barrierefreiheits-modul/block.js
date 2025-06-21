import { registerBlockType } from '@wordpress/blocks';
import './style.css';
import './editor.css';

registerBlockType('verein/barrierefreiheits-modul', {
  title: 'Barrierefreiheits-Modul',
  icon: 'universal-access',
  category: 'widgets',
  edit: () => <div className="barrierefreiheits-modul-block">Barrierefreiheits-Modul (Editor)</div>,
  save: () => <div className="barrierefreiheits-modul-block">Barrierefreiheits-Modul (Frontend)</div>,
});
