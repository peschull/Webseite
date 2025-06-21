import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, MediaUpload, MediaUploadCheck, InspectorControls } from '@wordpress/block-editor';
import { Button, PanelBody } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
  const { mitglieder = [] } = attributes;

  const updateMitglied = (index, field, value) => {
    const newMitglieder = [...mitglieder];
    newMitglieder[index] = { ...newMitglieder[index], [field]: value };
    setAttributes({ mitglieder: newMitglieder });
  };

  const addMitglied = () => {
    setAttributes({ mitglieder: [...mitglieder, { name: '', funktion: '', bild: 0, bildUrl: '' }] });
  };

  const removeMitglied = (index) => {
    const newMitglieder = [...mitglieder];
    newMitglieder.splice(index, 1);
    setAttributes({ mitglieder: newMitglieder });
  };

  return (
    <div {...useBlockProps()}>
      <InspectorControls>
        <PanelBody title={__('Teammitglieder verwalten', 'verein-menschlichkeit')}>
          <Button isSecondary onClick={addMitglied}>{__('Mitglied hinzufügen', 'verein-menschlichkeit')}</Button>
        </PanelBody>
      </InspectorControls>
      <div className="team-grid-editor">
        {mitglieder.map((mitglied, i) => (
          <div key={i} className="team-mitglied-editor" style={{ border: '1px solid #e5e7eb', borderRadius: '1em', padding: '1em', marginBottom: '1em' }}>
            <MediaUploadCheck>
              <MediaUpload
                onSelect={media => updateMitglied(i, 'bild', media.id) || updateMitglied(i, 'bildUrl', media.url)}
                allowedTypes={['image']}
                value={mitglied.bild}
                render={({ open }) => (
                  <Button onClick={open} isSecondary style={{ marginBottom: '0.5em' }}>
                    {mitglied.bildUrl ? <img src={mitglied.bildUrl} alt="" style={{ width: 64, height: 64, borderRadius: '50%' }} /> : __('Bild wählen', 'verein-menschlichkeit')}
                  </Button>
                )}
              />
            </MediaUploadCheck>
            <RichText
              tagName="div"
              value={mitglied.name}
              onChange={val => updateMitglied(i, 'name', val)}
              placeholder={__('Name', 'verein-menschlichkeit')}
              style={{ fontWeight: 'bold', fontSize: '1.1em' }}
            />
            <RichText
              tagName="div"
              value={mitglied.funktion}
              onChange={val => updateMitglied(i, 'funktion', val)}
              placeholder={__('Funktion', 'verein-menschlichkeit')}
              style={{ color: '#2563eb', fontSize: '1em' }}
            />
            <Button isDestructive onClick={() => removeMitglied(i)} style={{ marginTop: '0.5em' }}>{__('Entfernen', 'verein-menschlichkeit')}</Button>
          </div>
        ))}
      </div>
    </div>
  );
}
