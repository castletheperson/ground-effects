import {Configuration} from 'webpack';
import path from "path";
import HandlebarsPlugin from "handlebars-webpack-plugin";
import dotenv from "dotenv";

dotenv.config();

export default <Configuration>{
    plugins: [
        new HandlebarsPlugin({
            entry: path.join(process.cwd(), "src", "pages", "*.hbs"),
            partials: [path.join(process.cwd(), "src", "pages", "partials", "*.hbs")],
            data: process.env,
            output: path.join(process.cwd(), "static", "[name].html"),
        })
    ]
};
