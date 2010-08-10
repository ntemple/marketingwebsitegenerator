echo s3cmd -P put mwg-$1-update.zip s3://network.intellispire.com/mwg/core/1.2/
echo s3cmd -P put mwg-$1.zip s3://network.intellispire.com/mwg/core/1.2/
echo s3cmd -P put mwg-$1-1.2.0-update.zip s3://network.intellispire.com/mwg/core/1.2/

echo s3cmd -P put mwg-$1-update.zip s3://network.intellispire.com/mwg/latest-update.zip
echo s3cmd -P put mwg-$1.zip s3://network.intellispire.com/mwg/mwg-latest.zip

