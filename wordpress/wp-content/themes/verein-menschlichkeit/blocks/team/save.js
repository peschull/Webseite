import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
  const { mitglieder = [] } = attributes;
  return (
    <div {...useBlockProps.save()} className="team-grid">
      {mitglieder.map((mitglied, i) => (
        <div key={i} className="team-mitglied" style={{ display: 'inline-block', margin: '1em', textAlign: 'center' }}>
          {mitglied.bildUrl && <img src={mitglied.bildUrl} alt={mitglied.name} style={{ width: 96, height: 96, borderRadius: '50%', objectFit: 'cover', marginBottom: '0.5em' }} />}
          <RichText.Content tagName="div" value={mitglied.name} style={{ fontWeight: 'bold', fontSize: '1.1em' }} />
          <RichText.Content tagName="div" value={mitglied.funktion} style={{ color: '#2563eb', fontSize: '1em' }} />
        </div>
      ))}
    </div>
  );
}
