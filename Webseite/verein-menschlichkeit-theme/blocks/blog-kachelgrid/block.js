import { registerBlockType } from '@wordpress/blocks';
import './style.css';
import './editor.css';

registerBlockType('verein/blog-kachelgrid', {
  title: 'Blog Kachelgrid',
  icon: 'grid-view',
  category: 'widgets',
  edit: () => <div className="blog-kachelgrid">Blog Kachelgrid (Editor)</div>,
  save: () => <div className="blog-kachelgrid">Blog Kachelgrid (Frontend)</div>,
});
