const { execSync } = require('child_process');
const result = execSync('php D:/MTsN/artisan tinker --execute="use App\Models\Teacher; echo Teacher::where(\'is_principal\',true)->first()->bio;"', { encoding: 'utf8' });
console.log('Bio length:', result.trim().length);
console.log('Word count:', result.trim().split(/\s+/).length);
