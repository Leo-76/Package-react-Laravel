import { Head, router } from '@inertiajs/react';

export default function Dashboard({ user }) {
    function logout() {
        router.post(route('react-auth.logout'));
    }

    const initials = user.name
        .split(' ')
        .map(n => n[0])
        .join('')
        .toUpperCase()
        .slice(0, 2);

    return (
        <>
            <Head title="Dashboard" />

            <div className="min-h-screen bg-gray-50">

                {/* Navbar */}
                <nav className="bg-white border-b border-gray-100 px-6 py-4">
                    <div className="max-w-5xl mx-auto flex items-center justify-between">
                        <div className="flex items-center gap-2">
                            <div className="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                                <svg className="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <span className="font-semibold text-gray-900">ReactAuth</span>
                        </div>

                        <div className="flex items-center gap-3">
                            <div className="hidden sm:flex items-center gap-2">
                                <div className="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold flex items-center justify-center">
                                    {initials}
                                </div>
                                <span className="text-sm font-medium text-gray-700">{user.name}</span>
                            </div>
                            <button
                                onClick={logout}
                                className="btn-secondary text-xs px-3 py-1.5"
                            >
                                Sign out
                            </button>
                        </div>
                    </div>
                </nav>

                {/* Main */}
                <main className="max-w-5xl mx-auto px-6 py-10">

                    {/* Welcome Banner */}
                    <div className="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 text-white mb-8">
                        <p className="text-indigo-200 text-sm font-medium mb-1">Welcome back 👋</p>
                        <h1 className="text-3xl font-bold">{user.name}</h1>
                        <p className="mt-1 text-indigo-200">{user.email}</p>
                    </div>

                    {/* Stat Cards */}
                    <div className="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                        {[
                            { label: 'Account status', value: 'Active', color: 'text-emerald-600', bg: 'bg-emerald-50' },
                            { label: 'Member since', value: new Date(user.created_at).toLocaleDateString('en', { month: 'short', year: 'numeric' }), color: 'text-indigo-600', bg: 'bg-indigo-50' },
                            { label: 'Auth method', value: 'Email + Password', color: 'text-purple-600', bg: 'bg-purple-50' },
                        ].map((stat) => (
                            <div key={stat.label} className="card">
                                <p className="text-xs font-medium text-gray-500 uppercase tracking-wide">{stat.label}</p>
                                <p className={`mt-2 text-lg font-semibold ${stat.color}`}>{stat.value}</p>
                            </div>
                        ))}
                    </div>

                    {/* Info Box */}
                    <div className="card border-l-4 border-l-indigo-500">
                        <div className="flex items-start gap-4">
                            <div className="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                                <svg className="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 className="text-sm font-semibold text-gray-900">You're authenticated via <code className="bg-gray-100 px-1 rounded">laravel-react-auth</code></h3>
                                <p className="mt-1 text-sm text-gray-500">
                                    This dashboard is provided by the package. Publish the views to customise it, or extend the controller to add your own pages.
                                </p>
                                <div className="mt-3 flex gap-2 flex-wrap">
                                    <span className="inline-flex items-center px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-medium">Laravel</span>
                                    <span className="inline-flex items-center px-2.5 py-1 rounded-lg bg-cyan-50 text-cyan-700 text-xs font-medium">React</span>
                                    <span className="inline-flex items-center px-2.5 py-1 rounded-lg bg-purple-50 text-purple-700 text-xs font-medium">Inertia.js</span>
                                    <span className="inline-flex items-center px-2.5 py-1 rounded-lg bg-sky-50 text-sky-700 text-xs font-medium">Tailwind CSS</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </>
    );
}
