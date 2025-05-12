<div align="center">

# Video Testimonial Slider

[![WordPress](https://img.shields.io/badge/WordPress-Plugin-blue.svg)](https://wordpress.org)
[![Version](https://img.shields.io/badge/Version-1.2.0-green.svg)](https://github.com/Abbalochdev/Video-Testimonial-Slider)
[![License](https://img.shields.io/badge/License-GPL%20v2-blue.svg)](LICENSE)

A powerful and flexible WordPress plugin for creating beautiful video testimonial sliders with autoplay queue functionality.

[Features](#features) • [Installation](#installation) • [Usage](#usage) • [Documentation](#documentation) • [Support](#support)

</div>

---

## 🎯 Overview

Video Testimonial Slider is a professional WordPress plugin that enables you to create engaging video testimonial presentations on your website. Built with modern web standards and seamlessly integrated with WPBakery Page Builder, it offers a user-friendly interface for managing video testimonials.

## ✨ Features

- 🎥 **Dynamic Video Slider** - Smooth autoplay queue functionality
- 🎨 **WPBakery Integration** - Seamless integration with WPBakery Page Builder
- 📱 **Responsive Design** - Perfect display across all devices
- 🎯 **Easy Upload Interface** - Simple video management system
- 🛠️ **Customization Options** - Flexible styling and layout settings
- ⚡ **Performance Optimized** - Lightweight and fast loading
- 🔧 **Developer Friendly** - Clean code and hooks for customization

## 🚀 Installation

### Manual Installation

1. Download the plugin zip file
2. Log in to your WordPress dashboard
3. Navigate to Plugins → Add New
4. Click the 'Upload Plugin' button
5. Upload the zip file and click 'Install Now'
6. Activate the plugin

### Via Git

```bash
cd wp-content/plugins/
git clone https://github.com/Abbalochdev/Video-Testimonial-Slider.git
cd Video-Testimonial-Slider
```

## 📋 Requirements

- WordPress 4.0 or higher
- WPBakery Page Builder plugin
- PHP 7.2 or higher
- Modern web browser with JavaScript enabled

## 💻 Usage

### Basic Implementation

1. Navigate to WPBakery Page Builder elements
2. Locate "Video Testimonial Slider" under the "Content" category
3. Add the element to your page
4. Upload your video testimonials
5. Configure slider settings
6. Save and publish

### Shortcode Usage

```php
[ab_video_slider id="your_slider_id"]
```

### PHP Implementation

```php
<?php echo do_shortcode('[ab_video_slider id="your_slider_id"]'); ?>
```

## ⚙️ Configuration

### Available Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| autoplay | boolean | true | Enable/disable autoplay |
| delay | number | 5000 | Delay between slides (ms) |
| loop | boolean | true | Enable/disable loop |
| controls | boolean | true | Show/hide controls |

## 🛠️ Development

### Building from Source

1. Clone the repository
2. Install dependencies
```bash
npm install
```
3. Build the project
```bash
npm run build
```

## 📖 Documentation

For detailed documentation, please visit our [Wiki](https://github.com/Abbalochdev/Video-Testimonial-Slider/wiki)

## 🤝 Contributing

Contributions are welcome! Please read our [Contributing Guidelines](CONTRIBUTING.md) first.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the GPL v2 License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Author

**Abbalochdev**
- GitHub: [@Abbalochdev](https://github.com/Abbalochdev)

## 🙏 Support

If you find this plugin helpful, please consider:
- ⭐ Starring the GitHub repo
- 🐛 Creating GitHub issues for bug reports and feature requests
- 💻 Contributing to the code base

---

<div align="center">
Made with ❤️ by <a href="https://github.com/Abbalochdev">Abbalochdev</a>
</div>
