import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, InspectorControls, MediaUpload } from '@wordpress/block-editor';
import { PanelBody, Button } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
	const { title, paragraphs, backgroundImage } = attributes;
	return (
		<div {...useBlockProps()} className="textsplitter-block">
			<InspectorControls>
				<PanelBody title={__('Block-Einstellungen', 'textsplitter')}>
					<MediaUpload
						onSelect={(media) => setAttributes({ backgroundImage: media.url })}
						allowedTypes={['image']}
						value={backgroundImage}
						render={({ open }) => (
							<Button onClick={open} aria-label={__('Hintergrundbild wählen', 'textsplitter')}>
								{__('Bild auswählen', 'textsplitter')}
							</Button>
						)}
					/>
				</PanelBody>
			</InspectorControls>
			<RichText
				tagName="h2"
				value={title}
				onChange={(value) => setAttributes({ title: value })}
				placeholder={__('Titel eingeben…', 'textsplitter')}
			/>
			{/* Beispiel für dynamische Abschnitte (Paragraphs) */}
			{(paragraphs || []).map((para, idx) => (
				<RichText
					key={idx}
					tagName="p"
					value={para}
					onChange={(value) => {
						const newParas = [...paragraphs];
						newParas[idx] = value;
						setAttributes({ paragraphs: newParas });
					}}
					placeholder={__('Abschnitt…', 'textsplitter')}
				/>
			))}
			<Button
				onClick={() => setAttributes({ paragraphs: [...(paragraphs || []), ''] })}
				variant="secondary"
			>
				{__('Abschnitt hinzufügen', 'textsplitter')}
			</Button>
		</div>
	);
}
