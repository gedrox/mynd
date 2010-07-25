<?php

namespace Ganga\Doctrine;

use Doctrine\ORM\Tools\Export\Driver\YamlExporter,
	Doctrine\ORM\Mapping\ClassMetadataInfo;

/**
 * Modified yaml export driver
 */
class YamlExportDriver extends YamlExporter
{

	protected $classNamespace;

	/**
     * {@inheritDoc}
	 */
	public function __construct($dir = null)
	{
		parent::__construct($dir);
		$this->classNamespace = \PROJECT_NAME . '\Entity\\';
	}

	/**
     * Set the array of ClassMetadataInfo instances to export
     *
     * @param array $metadata
     * @return void
     */
    public function setMetadata(array $metadata)
    {
        $this->_metadata = $metadata;
		/* @var $metadata ClassMetadataInfo */
		foreach ($this->_metadata as &$metadata) {
			$metadata->name = $this->classNamespace . $metadata->name;

			foreach ($metadata->associationMappings as &$associationMapping) {
				/* @var $associationMapping \Doctrine\ORM\Mapping\AssociationMapping */
				$associationMapping->targetEntityName = $this->classNamespace . $associationMapping->targetEntityName;
				$associationMapping->sourceEntityName = $this->classNamespace . $associationMapping->sourceEntityName;
			}
		}
    }
}