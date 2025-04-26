import preset from "../../../../vendor/filament/filament/tailwind.config.preset";

export default {
    presets: [preset],
    content: [
        "./Modules/*/app/Filament/**/*.php",
        "./Modules/*/resources/views/filament/**/*.blade.php",
        "./Modules/*/vendor/filament/**/*.blade.php",
    ],
};
