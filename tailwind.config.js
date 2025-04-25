module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                primary: '#4361ee',
                secondary: '#3f37c9',
                accent: '#4895ef',
                dark: '#1a1a2e',
                light: '#f8f9fa',
                success: '#4cc9f0',
            },
            fontFamily: {
                poppins: ['Poppins', 'sans-serif'],
            },
            animation: {
                float: 'float 35s infinite linear',
                pulse: 'pulse 5s infinite',
            },
            keyframes: {
                float: {
                    '0%': { transform: 'translateY(0) rotate(0deg)' },
                    '50%': { transform: 'translateY(-20px) rotate(180deg)' },
                    '100%': { transform: 'translateY(0) rotate(360deg)' },
                },
                pulse: {
                    '0%, 100%': { transform: 'scale(1)' },
                    '50%': { transform: 'scale(1.05)' },
                }
            },
           
        }
    
    },
    plugins: [],
    
};