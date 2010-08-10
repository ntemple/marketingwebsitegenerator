rm -rf mwg-$1
rm -f mwg-$1*.zip
rm -rf out

# Full
svn export https://marketingwebsitegenerator.googlecode.com/svn/tags/script/mwg-$1
chmod -R g-w *
chown -R ntemple:ntemple *
rm -rf mwg-$1/tests/
pushd mwg-$1; 
zip -r ../mwg-$1.zip *
popd
echo s3cmd -P put mwg-$1.zip s3://network.intellispire.com/mwg/core/1.2/

# Incremental from 1.2.0
# Does not touch currnet checkout
rm -f files-$1.txt
svn diff --summarize https://marketingwebsitegenerator.googlecode.com/svn/tags/script/mwg-1.2.0 https://marketingwebsitegenerator.googlecode.com/svn/tags/script/mwg-$1 | grep -v test |  grep -v "^D" | cut -b 84- > files-$1.txt

./release-incremental.php $1


# Upgrade from 1.0: basically everything except install files and dirs
# cleans current checkout
mv mwg-$1/templates mwg-$1/templates-1.2
rm mwg-$1/config/constants.php
rm -rf mwg-$1/tests/
rm -rf mwg-$1/tmp
rm -rf mwg-$1/_tmp
rm -rf mwg-$1/downloads
rm -rf mwg-$1/fonts
rm -rf mwg-$1/css
rm -rf mwg-$1/install
pushd mwg-$1;
zip -r ../mwg-$1-update.zip *
popd

echo s3cmd -P put mwg-$1-update.zip s3://network.intellispire.com/mwg/core/1.2/
echo s3cmd -P put mwg-$1.zip s3://network.intellispire.com/mwg/core/1.2/
echo s3cmd -P put mwg-$1-1.2.0-update.zip s3://network.intellispire.com/mwg/core/1.2/

