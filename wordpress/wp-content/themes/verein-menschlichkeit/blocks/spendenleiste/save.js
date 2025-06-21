import { useBlockProps } from '@wordpress/block-editor';

export default function save({ attributes }) {
  const { ziel, stand, farbe } = attributes;
  const prozent = Math.min(100, Math.round((stand / ziel) * 100));
  return (
    <div {...useBlockProps.save()} style={{ padding: '1em', background: '#f4f7ff', borderRadius: '1em', textAlign: 'center' }}>
      <div style={{ fontWeight: 'bold', marginBottom: '0.5em' }}>Spendenfortschritt</div>
      <div style={{ background: '#e5e7eb', borderRadius: '1em', height: '2em', width: '100%', overflow: 'hidden', marginBottom: '0.5em' }}>
        <div style={{ width: prozent + '%', background: farbe, height: '100%', transition: 'width 0.5s' }}></div>
      </div>
      <div style={{ fontSize: '1.1em' }}>{stand} € von {ziel} € ({prozent}%)</div>
    </div>
  );
}
