# Git & GitHub Quick Reference

## Git Basics

### Initialize Repository
```bash
cd "C:\Your\Project\Path"
git init
```

### Check Status
```bash
git status  # See changed files
git log     # See commit history
git diff    # See what changed
```

### Add & Commit
```bash
# Add specific file
git add filename.html

# Add all files
git add .

# Commit with message (must be meaningful!)
git commit -m "Add contact form with validation"
```

### View Commit History
```bash
git log                           # All commits
git log --oneline                 # Compact view
git log --stat                    # With file changes
git log -p                        # With code diffs
git log --graph --oneline --all   # Visual tree
```

---

## Meaningful Commit Messages

### Format
```
[Type]: Short description (50 chars max)

Optional longer explanation (optional)
- Bullet point 1
- Bullet point 2
```

### Types
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation
- `style`: Formatting (no code change)
- `refactor`: Code restructure (no behavior change)
- `test`: Adding tests
- `chore`: Maintenance

### Examples

**Good Commits:**
```
feat: Add contact form validation with real-time feedback

- Implement name, email, subject validation
- Show error messages on blur
- Clear errors as user types
- Prevent form submission if invalid
```

```
fix: Correct mobile menu toggle not closing

- Add event listener for menu close on link click
- Fix z-index issue for mobile menu
- Test on iOS and Android devices
```

```
docs: Add XAMPP setup and database configuration

- Create XAMPP_SETUP.md with installation steps
- Add DATABASE_SETUP.md with import instructions
- Document troubleshooting for common issues
```

**Bad Commits:**
```
fixed stuff                    # Too vague
updated                        # Not descriptive
x                              # Meaningless
multiple unrelated changes     # Should be separate commits
```

---

## Portfolio Project Commits (10+)

### Commit Timeline

1. **Initial Setup**
   - `git init`
   - Add .gitignore, README.md
   - Create project structure

2. **HTML5 Structure**
   - Create index.html with semantic markup
   - Add SETUP.html guide
   - Document HTML5 features

3. **CSS3 Styling**
   - Add css/style.css with flexbox and grid
   - Implement responsive design
   - Add CSS animations

4. **JavaScript**
   - Add js/script.js with form validation
   - Implement mobile menu toggle
   - Add smooth scroll navigation

5. **PHP Backend**
   - Create php/contact.php form handler
   - Add input validation and sanitization
   - Implement JSON response format

6. **MySQL Database**
   - Create database/portfolio_db.sql schema
   - Add sample data
   - Document database design

7. **Documentation**
   - Add API documentation
   - Create testing guide
   - Write deployment instructions

8. **Improvements**
   - Fix bugs and polish UX
   - Add error handling
   - Optimize performance

---

## GitHub Integration

### Create GitHub Account
1. Go to: https://github.com
2. Click "Sign up"
3. Create free account

### Create New Repository
1. Click "New" on GitHub
2. Repository name: `portfolio`
3. Description: "Full-stack portfolio website"
4. Public (for portfolio showcase)
5. Initialize with README (optional)
6. Create repository

### Connect Local to GitHub
```bash
# Add remote (from GitHub instructions)
git remote add origin https://github.com/YOUR_USERNAME/portfolio.git

# Verify remote
git remote -v

# Push to GitHub
git branch -M main
git push -u origin main

# Future pushes
git push  # Shorthand
```

### Clone Repository
```bash
git clone https://github.com/YOUR_USERNAME/portfolio.git
cd portfolio

# Set upstream for pulling updates
git pull origin main
```

---

## Common Git Workflows

### Feature Branch (Best Practice)
```bash
# Create feature branch
git checkout -b feature/contact-form

# Make changes and commits
git add .
git commit -m "Add contact form"

# Push to GitHub
git push origin feature/contact-form

# On GitHub: Create Pull Request (PR)
# After review and approval: Merge to main

# Update local main
git checkout main
git pull origin main
```

### Undo Changes
```bash
# Undo unstaged changes (file level)
git restore filename.html

# Undo all unstaged changes
git restore .

# Unstage specific file
git restore --staged filename.html

# Undo last commit (keep changes)
git reset HEAD~1

# Undo last commit (discard changes)
git reset --hard HEAD~1
```

### View File History
```bash
# Changes in commit
git show commit_hash

# File history
git log filename.html

# Who changed each line
git blame filename.html

# File history with diffs
git log -p filename.html
```

---

## GitHub Pages Deployment

### Enable Pages
1. Go to GitHub repository Settings
2. Pages → Branch: main
3. Folder: / (root)
4. Save

### Access Published Site
- URL: https://YOUR_USERNAME.github.io/portfolio/
- Wait 2-5 minutes for deployment

### Note
- GitHub Pages serves static files (HTML, CSS, JS)
- PHP and MySQL won't work on GitHub Pages
- Use for front-end only or deploy PHP separately

---

## Commit Count Verification

```bash
git rev-list --count HEAD  # Total commits
git log --oneline | wc -l  # Commit count (bash)
git log --oneline          # List all commits
```

---

## Portfolio Showcase Checklist

- [ ] 10+ meaningful commits
- [ ] Clear commit messages
- [ ] README.md with project info
- [ ] Source code visible on GitHub
- [ ] Live URL (if deployed)
- [ ] Mention in job applications
- [ ] Link on resume/portfolio

---

## Tips for Better Git History

1. **Commit frequently** - Small, logical chunks
2. **Write clear messages** - Future you will thank you
3. **One feature per commit** - Easy to revert if needed
4. **Don't mix refactoring with features** - Separate commits
5. **Use branches** - Keep main stable
6. **Review before committing** - Stage only what you want
7. **Push regularly** - Backup to GitHub

---

## Next Steps

1. Initialize git: `git init`
2. Make commits: `git commit -m "message"`
3. Create GitHub account
4. Create repository
5. Push to GitHub: `git push -u origin main`
6. Share portfolio link
