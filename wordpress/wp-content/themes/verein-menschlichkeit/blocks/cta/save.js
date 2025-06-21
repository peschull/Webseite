import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
  const { text, url, backgroundColor, textColor } = attributes;
  return (
    <div {...useBlockProps.save()} style={{ backgroundColor, color: textColor, padding: '2em', borderRadius: '1em', textAlign: 'center' }}>
      <RichText.Content tagName="div" value={text} style={{ fontSize: '2em', fontWeight: 'bold' }} />
      <div style={{ marginTop: '1em' }}>
        <a href={url} className="cta-btn" style={{ background: textColor, color: backgroundColor, padding: '0.75em 2em', borderRadius: '2em', textDecoration: 'none', fontWeight: 'bold', fontSize: '1.2em' }}>
          Jetzt mitmachen
        </a>
      </div>
    </div>
  );
}
