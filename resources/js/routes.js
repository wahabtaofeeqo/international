import CompleteRegistration from './components/auth/CompleteRegistration.vue'
import CreateAccount from './components/auth/Register.vue'
import Register from './components/Register.vue'

import UserDashboard from './components/user/Dashboard.vue'
import EditorDashboard from './components/editor/Dashboard.vue'
import AdminDashboard from './components/admin/Dashboard.vue'
import SuperDashboard from './components/super/Dashboard.vue'

import Languages from './components/super/Languages.vue'
import LocationIndex from './components/super/Location/Index.vue'
import LocationCountry from './components/super/Location/Country.vue'
import LocationRegion from './components/super/Location/Region.vue'
import LocationCity from './components/super/Location/City.vue'

import MembershipIndex from './components/sections/Organization/Membership/Index.vue'
import MembersManage from './components/sections/Organization/Membership/Members.vue'
import MembersRequests from './components/sections/Organization/Membership/Requests.vue'
import MembersAdd from './components/sections/Organization/Membership/Add.vue'

import NewslettersIndex from './components/sections/Organization/Newsletter/Index.vue'
import NewslettersCreate from './components/sections/Organization/Newsletter/Create.vue'
import NewslettersManage from './components/sections/Organization/Newsletter/Manage.vue'

import BlogIndex from './components/sections/Organization/Blog/Index.vue'
import BlogCreate from './components/sections/Organization/Blog/Create.vue'
import BlogManage from './components/sections/Organization/Blog/Manage.vue'
import BlogComment from './components/sections/Organization/Blog/Comments.vue'

import Messages from './components/sections/Organization/Messages.vue'
import Subscribers from './components/sections/Organization/Subscribers.vue'

import SettingsIndex from './components/sections/Organization/Settings/Index.vue'
import Routing from './components/sections/Organization/Settings/Routing.vue'
import OrganizationProfile from './components/sections/Organization/Settings/Profile.vue'

// General routes for all users
import Profile from './components/Profile.vue'
import ErrorPage from './components/ErrorPage.vue'

/**
	* Public Access of Organizations
*/
import OrganizationIndex from './components/pages/organization/Index.vue'
import OrganizationHome from './components/pages/organization/Home.vue'
import OrganizationRegister from './components/pages/organization/Register.vue'
import OrganizationSinglePost from './components/pages/organization/blog/Post.vue' 

const routes = [
	{
		path: '/organization/:id',
		component: OrganizationIndex,
		children: [
			{
				path: '',
				name: 'OrganizationHome',
				component: OrganizationHome
			}, 
			{
				path: 'register',
				name: 'OrganizationRegister',
				component: OrganizationRegister
			},
			{
				path: '/post/:post_id',
				name: 'OrganizationSinglePost',
				component: OrganizationSinglePost
			},
		]
	},

	{
		path: '/register',
		component: Register,
		children: [
			{
				path: '',
				name: 'CreateAccount',
				component: CreateAccount
			},
			{
				path: 'complete',
				name: 'CompleteRegistration',
				component: CompleteRegistration,
			}
		]
	},

	/**
		* User
	*/
	{
		path: '/user',
		name: 'UserDashboard',
		component: UserDashboard,
	},
	{
		path: '/user/profile',
		component: Profile,
	},

	/**
		* Editor
	*/
	{
		path: '/editor',
		name: 'EditorDashboard',
		component: EditorDashboard,
	},
	{
		path: '/editor/profile',
		component: Profile,
	},
	{
		path: '/editor/blog',
		component: BlogIndex,
		children: [
			{
				path: '',
				component: BlogCreate
			},
			{
				path: 'manage',
				component: BlogManage
			},
			{
				path: 'comments',
				component: BlogComment
			},
		]
	},
	{
		path: '/editor/newsletters',
		component: NewslettersIndex,
		children: [
			{
				path: '',
				component: NewslettersCreate
			},
			{
				path: 'manage',
				component: NewslettersManage
			},
		]
	},

	/**
		* Admin
	*/
	{
		path: '/admin',
		name: 'AdminDashboard',
		component: AdminDashboard,
	},
	{
		path: '/admin/membership',
		component: MembershipIndex,
		children: [
			{
				path: '',
				name: 'AdminMembers',
				component: MembersManage
			},
			{
				path: 'requests',
				name: 'AdminMembersRequests',
				component: MembersRequests
			},
			{
				path: 'add',
				name: 'AdminMembersAdd',
				component: MembersAdd
			}
		]
	},
	{
		path: '/admin/blog',
		component: BlogIndex,
		children: [
			{
				path: '',
				component: BlogCreate
			},
			{
				path: 'manage',
				component: BlogManage
			},
			{
				path: 'comments',
				component: BlogComment
			},
		]
	},
	{
		path: '/admin/newsletters',
		component: NewslettersIndex,
		children: [
			{
				path: '',
				component: NewslettersCreate
			},
			{
				path: 'manage',
				component: NewslettersManage
			},
		]
	},
	{
		path: '/admin/messages',
		component: Messages,
	},
	{
		path: '/admin/subscribers',
		component: Subscribers,
	},
	{
		path: '/admin/settings',
		component: SettingsIndex,
		children: [
			{
				path: '',
				component: OrganizationProfile
			},
			{
				path: 'routing',
				component: Routing
			},
		]
	},
	{
		path: '/admin/profile',
		component: Profile,
	},

	/**
		* Super
	*/
	{
		path: '/super',
		name: 'SuperDashboard',
		component: SuperDashboard,
	},
	{
		path: '/super/membership',
		component: MembershipIndex,
		children: [
			{
				path: '',
				name: 'SuperMembers',
				component: MembersManage
			},
			{
				path: 'requests',
				name: 'SuperMembersRequests',
				component: MembersRequests
			},
			{
				path: 'add',
				name: 'SuperMembersAdd',
				component: MembersAdd
			}
		]
	},
	{
		path: '/super/blog',
		component: BlogIndex,
		children: [
			{
				path: '',
				component: BlogCreate
			},
			{
				path: 'manage',
				component: BlogManage
			},
			{
				path: 'comments',
				component: BlogComment
			},
		]
	},
	{
		path: '/super/newsletters',
		component: NewslettersIndex,
		children: [
			{
				path: '',
				component: NewslettersCreate
			},
			{
				path: 'manage',
				component: NewslettersManage
			},
		]
	},
	{
		path: '/super/location',
		component: LocationIndex,
		children: [
			{
				path: '',
				component: LocationCountry
			},
			{
				path: 'region',
				component: LocationRegion
			},
			{
				path: 'city',
				component: LocationCity
			},
		]
	},
	{
		path: '/super/languages',
		component: Languages,
	},
	{
		path: '/super/messages',
		component: Messages,
	},
	{
		path: '/super/subscribers',
		component: Subscribers,
	},
	{
		path: '/super/settings',
		component: SettingsIndex,
		children: [
			{
				path: '',
				component: OrganizationProfile
			},
			{
				path: 'routing',
				component: Routing
			},
		]
	},
	{
		path: '/super/settings',
		component: SettingsIndex,
		children: [
			{
				path: '',
				component: OrganizationProfile
			},
			{
				path: 'routing',
				component: Routing
			},
		]
	},
	{
		path: '/super/profile',
		component: Profile,
	},

	/**
		* 404
	*/
	{
		path: '/user/*',
		component: ErrorPage,
	},
	{
		path: '/editor/*',
		component: ErrorPage,
	},
	{
		path: '/admin/*',
		component: ErrorPage,
	},
	{
		path: '/super/*',
		component: ErrorPage,
	},
]

export default routes