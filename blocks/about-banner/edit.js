// blocks/about-banner/edit.js
import { __ } from '@wordpress/i18n';
import { 
  useBlockProps, 
  InspectorControls,
  RichText 
} from '@wordpress/block-editor';
import { 
  PanelBody, 
  ColorPaletteControl,
  __experimentalNumberControl as NumberControl
} from '@wordpress/components';
import { MediaUpload, MediaUploadCheck } from '@wordpress/media-utils';

export default function Edit({ attributes, setAttributes }) {
  const { gradientStart, gradientEnd, title, content, mediaId, mediaUrl, mediaAlt } = attributes;

  return (
    <div {...useBlockProps({
      style: { background: `linear-gradient(135deg, ${gradientStart}, ${gradientEnd}` },
      className: 'about-banner-block'
    })}>
      <InspectorControls>
        <PanelBody title={__('Color Settings')}>
          <ColorPaletteControl
            label={__('Gradient Start')}
            value={gradientStart}
            onChange={(newColor) => setAttributes({ gradientStart: newColor })}
          />
          <ColorPaletteControl
            label={__('Gradient End')}
            value={gradientEnd}
            onChange={(newColor) => setAttributes({ gradientEnd: newColor })}
          />
        </PanelBody>
        
        <PanelBody title={__('Image Settings')}>
          <MediaUploadCheck>
            <MediaUpload
              onSelect={(media) => setAttributes({
                mediaId: media.id,
                mediaUrl: media.url,
                mediaAlt: media.alt || ''
              })}
              allowedTypes={['image']}
              value={mediaId}
              render={({ open }) => (
                <button 
                  onClick={open}
                  className={!mediaUrl ? 'button button-large' : ''}
                >
                  {!mediaUrl ? __('Upload Image') : (
                    <img 
                      src={mediaUrl} 
                      alt={__('Banner preview')} 
                      style={{ maxWidth: '200px' }} 
                    />
                  )}
                </button>
              )}
            />
          </MediaUploadCheck>
          
          {mediaUrl && (
            <NumberControl
              label={__('Image Max Width (px)')}
              value={attributes.imageWidth || 350}
              onChange={(value) => setAttributes({ imageWidth: value })}
              min={100}
              max={800}
            />
          )}
        </PanelBody>
      </InspectorControls>

      <div className="banner-container">
        <div className="banner-content">
          <RichText
            tagName="h1"
            value={title}
            onChange={(newTitle) => setAttributes({ title: newTitle })}
            placeholder={__('Enter title...')}
            allowedFormats={[]}
          />
          <RichText
            tagName="p"
            value={content}
            onChange={(newContent) => setAttributes({ content: newContent })}
            placeholder={__('Enter content...')}
            allowedFormats={['bold', 'italic', 'link']}
          />
        </div>

        {mediaUrl && (
          <div className="banner-image" style={{ maxWidth: attributes.imageWidth + 'px' }}>
            <img
              src={mediaUrl}
              alt={mediaAlt}
              className="banner-img"
            />
          </div>
        )}
      </div>
    </div>
  );
}