const path = require("path");

module.exports = {
	pages: {
		index: {
			entry: "src/js/main.ts",
			template: "public/index.html"
		}
	},
	configureWebpack: {
		resolve: {
			alias: {
				"@": path.resolve(__dirname, "src/js")
			}
		}
	},
	devServer: {
		proxy: "http://localhost:8000"
	}
};
