ECHO >>> Creating yaml files...
doctrine orm:convert-mapping --from-database ganga_yaml ..\database\yml\
ECHO >>> Creating entities...
doctrine orm:generate-entities ..\models\
ECHO >>> Generating proxies...
doctrine orm:generate-proxies