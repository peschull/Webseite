import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
	const { title, paragraphs } = attributes;
	return (
		<div {...useBlockProps.save()} className="textsplitter-block">
			<RichText.Content tagName="h2" value={title} />
			<div className="splitter-abschnitte">
				{(paragraphs || []).map((para, idx) => (
					<RichText.Content key={idx} tagName="p" value={para} />
				))}
			</div>
		</div>
	);
}
