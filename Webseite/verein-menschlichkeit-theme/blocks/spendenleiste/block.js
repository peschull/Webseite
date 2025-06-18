import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, PanelColorSettings } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
  const { ziel, stand, farbe } = attributes;
  const prozent = Math.min(100, Math.round((stand / ziel) * 100));
  return (
    <div {...useBlockProps()} style={{ padding: '1em', background: '#f4f7ff', borderRadius: '1em', textAlign: 'center' }}>
      <InspectorControls>
        <PanelBody title={__('Spendenziel', 'verein-menschlichkeit')}>
          <RangeControl
            label={__('Zielbetrag (€)', 'verein-menschlichkeit')}
            value={ziel}
            onChange={(val) => setAttributes({ ziel: val })}
            min={100}
            max={10000}
            step={50}
          />
          <RangeControl
            label={__('Bisher erreicht (€)', 'verein-menschlichkeit')}
            value={stand}
            onChange={(val) => setAttributes({ stand: val })}
            min={0}
            max={ziel}
            step={10}
          />
        </PanelBody>
        <PanelColorSettings
          title={__('Farben', 'verein-menschlichkeit')}
          colorSettings={[
            {
              value: farbe,
              onChange: (color) => setAttributes({ farbe: color }),
              label: __('Farbe der Leiste', 'verein-menschlichkeit'),
            },
          ]}
        />
      </InspectorControls>
      <div style={{ fontWeight: 'bold', marginBottom: '0.5em' }}>{__('Spendenfortschritt', 'verein-menschlichkeit')}</div>
      <div style={{ background: '#e5e7eb', borderRadius: '1em', height: '2em', width: '100%', overflow: 'hidden', marginBottom: '0.5em' }}>
        <div style={{ width: prozent + '%', background: farbe, height: '100%', transition: 'width 0.5s' }}></div>
      </div>
      <div style={{ fontSize: '1.1em' }}>{stand} € {__('von', 'verein-menschlichkeit')} {ziel} € ({prozent}%)</div>
    </div>
  );
}
