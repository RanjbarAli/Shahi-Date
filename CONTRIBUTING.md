# Contributing to Shahi Date

Thank you for considering contributing to Shahi Date! We welcome contributions from everyone.

## راهنمای مشارکت

از اینکه به فکر مشارکت در پروژه Shahi Date هستید، از شما سپاسگزاریم! 

## How to Contribute

### Reporting Bugs

If you find a bug, please create an issue on GitHub with:
- A clear title and description
- Steps to reproduce the bug
- Expected behavior vs actual behavior
- Your PHP and Laravel versions
- Code samples if possible

### Suggesting Enhancements

We love to receive suggestions! Please create an issue with:
- A clear title and description
- Why this enhancement would be useful
- Examples of how it would work

### Pull Requests

1. **Fork the repository**
   ```bash
   git clone https://github.com/RanjbarAli/Shahi-Date.git
   cd Shahi-Date
   ```

2. **Create a new branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```

3. **Make your changes**
   - Write clear, readable code
   - Follow PSR-12 coding standards
   - Add tests for new features
   - Update documentation if needed

4. **Run tests**
   ```bash
   composer test
   ```

5. **Run code style fixer**
   ```bash
   composer format
   ```

6. **Commit your changes**
   ```bash
   git commit -m "Add: your feature description"
   ```
   
   Use clear commit messages:
   - `Add: new feature`
   - `Fix: bug description`
   - `Update: documentation changes`
   - `Refactor: code improvements`

7. **Push to your fork**
   ```bash
   git push origin feature/your-feature-name
   ```

8. **Create a Pull Request**
   - Go to the original repository
   - Click "New Pull Request"
   - Select your branch
   - Describe your changes clearly
   - Reference any related issues

## Development Setup

1. **Install dependencies**
   ```bash
   composer install
   ```

2. **Run tests**
   ```bash
   composer test
   ```

3. **Check code style**
   ```bash
   composer format
   ```

## Coding Standards

- Follow **PSR-12** coding style
- Write clear, self-documenting code
- Add PHPDoc blocks for all public methods
- Use type hints for parameters and return types
- Keep methods focused and concise

## Testing

- Write tests for all new features
- Ensure all tests pass before submitting PR
- Aim for high test coverage
- Test edge cases and error conditions

### Running Tests

```bash
# Run all tests
composer test

# Run specific test
vendor/bin/phpunit tests/ShahiTest.php

# Run with coverage
vendor/bin/phpunit --coverage-html coverage
```

## Documentation

- Update README.md if adding new features
- Add examples for new functionality
- Keep documentation clear and concise
- Support both English and Persian documentation

## Code Review Process

1. All submissions require review
2. Maintainers will review your PR
3. Address any requested changes
4. Once approved, your PR will be merged

## Community Guidelines

- Be respectful and constructive
- Help others learn and grow
- Follow the code of conduct
- Ask questions if unsure

## Questions?

Feel free to:
- Open an issue for questions
- Contact maintainers
- Join discussions

## License

By contributing, you agree that your contributions will be licensed under the MIT License.

---

## مراحل مشارکت به فارسی

### گزارش باگ
اگر باگی پیدا کردید، یک issue با این اطلاعات ایجاد کنید:
- عنوان و توضیح واضح
- مراحل بازتولید باگ
- رفتار مورد انتظار و رفتار واقعی
- نسخه PHP و Laravel شما
- نمونه کد در صورت امکان

### پیشنهاد بهبود
برای پیشنهاد ویژگی جدید:
- عنوان و توضیح واضح
- دلیل مفید بودن این ویژگی
- مثال‌هایی از نحوه کارکرد

### نصب و توسعه
```bash
# نصب وابستگی‌ها
composer install

# اجرای تست‌ها
composer test

# بررسی استاندارد کد
composer format
```

### استانداردهای کدنویسی
- از استاندارد PSR-12 پیروی کنید
- تست برای تمام ویژگی‌های جدید بنویسید
- مستندات را به‌روز کنید
- از Type Hints استفاده کنید

با تشکر از مشارکت شما! 🙏
