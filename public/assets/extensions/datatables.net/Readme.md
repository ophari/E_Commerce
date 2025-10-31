# DataTables for jQuery

This package contains distribution files for the [DataTables library](https://datatables.net) for [jQuery](http://jquery.com/).  
Only the core software for this library is contained in this package — to be correctly styled, a styling package for DataTables must also be included.  
Styling options include DataTables’ native styling, [Bootstrap](http://getbootstrap.com), and [Foundation](http://foundation.zurb.com/).

DataTables is a table-enhancing library that adds features such as paging, ordering, searching, scrolling, and many more to a static HTML table.  
A comprehensive API is also available to manipulate the table. Please refer to the [DataTables website](https://datatables.net) for a full range of documentation and examples.

---

## Table of Contents

- [Installation](#installation)
  - [Browser](#browser)
  - [npm](#npm)
  - [bower](#bower)
- [Documentation](#documentation)
- [Bug / Support](#bug--support)
- [Contributing](#contributing)
- [License](#license)

---

## Installation

### Browser

For inclusion of this library using a standard `<script>` tag, it is recommended that you use the [DataTables download builder](https://datatables.net/download),  
which can create CDN or locally hosted packages for you, with all dependencies satisfied.

### npm

```bash
npm install datatables.net
```

ES3 Syntax
```
var $ = require('jquery');
require('datatables.net')(window, $);
```

ES6 Syntax
```
import 'datatables.net';
```

### bower

```
bower install --save datatables.net
```



## Documentation

Full documentation of the DataTables options, API and plug-in interface are available on the [website](https://datatables.net/reference/index). The site also contains information on the wide variety of plug-ins that are available for DataTables, which can be used to enhance and customise your table even further.   


## Bug / Support

Support for DataTables is available through the [DataTables forums](//datatables.net/forums) and [commercial support options](//datatables.net/support) are available.


### Contributing

If you are thinking of contributing code to DataTables, first of all, thank you! All fixes, patches and enhancements to DataTables are very warmly welcomed. This repository is a distribution repo, so patches and issues sent to this repo will not be accepted. Instead, please direct pull requests to the [DataTables/DataTablesSrc](http://github.com/DataTables/DataTablesSrc). For issues / bugs, please direct your questions to the [DataTables forums](//datatables.net/forums).


## License

This software is released under the [MIT license](//datatables.net/license). You are free to use, modify and distribute this software, but all copyright information must remain.
