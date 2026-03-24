const fs = require('fs').promises;
const path = require('path');

async function main() {
  const binDir = path.resolve(__dirname, '..', 'node_modules', '.bin');

  try {
    const files = await fs.readdir(binDir);

    await Promise.all(
      files.map(async (fileName) => {
        const filePath = path.join(binDir, fileName);

        try {
          await fs.chmod(filePath, 0o755);
        } catch (err) {
        }
      })
    );

    console.log('Permission fix attempted on', binDir);
  } catch (err) {
    console.log('No node_modules/.bin found or chmod failed:', err.message);
  }
}

main();
