import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, InspectorControls, ColorPalette, URLInputButton } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
  const { text, url, backgroundColor, textColor } = attributes;
  return (
    <div {...useBlockProps()} style={{ backgroundColor, color: textColor, padding: '2em', borderRadius: '1em', textAlign: 'center' }}>
      <InspectorControls>
        <PanelBody title={__('Farben', 'verein-menschlichkeit')}>
          <p>{__('Hintergrundfarbe', 'verein-menschlichkeit')}</p>
          <ColorPalette value={backgroundColor} onChange={(color) => setAttributes({ backgroundColor: color })} />
          <p>{__('Textfarbe', 'verein-menschlichkeit')}</p>
          <ColorPalette value={textColor} onChange={(color) => setAttributes({ textColor: color })} />
        </PanelBody>
      </InspectorControls>
      <RichText
        tagName="div"
        value={text}
        onChange={(val) => setAttributes({ text: val })}
        placeholder={__('Jetzt mitmachen!', 'verein-menschlichkeit')}
        style={{ fontSize: '2em', fontWeight: 'bold' }}
      />
      <div style={{ marginTop: '1em' }}>
        <URLInputButton
          url={url}
          onChange={(val) => setAttributes({ url: val })}
        />
      </div>
    </div>
  );
}
